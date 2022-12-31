<?php

namespace App\Http\Livewire;

use Auth;
use Illuminate\View\View;
use LdapRecord\LdapRecordException;
use LdapRecord\Models\Model;
use LdapRecord\Models\ModelDoesNotExistException;
use LdapRecord\Models\OpenLDAP\Entry;
use LdapRecord\Models\OpenLDAP\Group as BaseGroup;
use LdapRecord\Models\OpenLDAP\User;
use LdapRecord\Query\Collection;
use Livewire\Component;

class Group extends BaseGroup
{
    public static $objectClasses = ['top', 'apple-group', 'posixGroup'];
}

class SyncLdap extends Component
{

//    public $posix;
//    public $ldap;
//
    public function mount()
    {
        if (session()->has('success') || session()->has('synced')) {
            redirect('/');
        }
//        $this->posix = $this->checkPosix($this->ldap);
    }

    public function syncUser()
    {
        $user = Auth::user()->ldap;
        $ldap_user = User::find($user['dn']);

        if ($ldap_user) {
            if (!$this->checkPosix($ldap_user))
            {
                if (config('sync.sync_type') == 'posix' || config('sync.sync_type') == 'full')
                {
//                    $ldap_user->setAttribute('objectclass', array_merge($ldap_user->getAttribute('objectclass'), ['posixAccount', 'top']));
                    $ldap_user->setAttribute('objectclass', array_merge($ldap_user->getAttribute('objectclass'), ['posixAccount']));
                    $ldap_user->setAttribute('uidnumber', $this->getUidNumber());
                    $ldap_user->setAttribute('gidnumber', 1000001);
                    $ldap_user->setAttribute('displayname', $ldap_user->getFirstAttribute('cn') . ' ' . $ldap_user->getFirstAttribute('sn'));
                    $ldap_user->setAttribute('homedirectory', '/home/' . $ldap_user->getFirstAttribute('displayname'));
                    $ldap_user->setAttribute('loginshell', '/bin/sh');
//                    TODO: figure out why memberof isnt saving
//                    $ldap_user->setAttribute('memberof', 'cn=users,cn=groups,{base}');
//                    dd($ldap_user);
                    try {
                        $ldap_user->save();
                    } catch (LdapRecordException $e) {
//                        session()->flash('error', $e->getMessage());
                        dd($e->getMessage());
                    }
                }

                try {
                    $this->updateGroup($ldap_user);
                } catch (ModelDoesNotExistException $e) {
                } catch (LdapRecordException $e) {
                }

                session(['success' => $ldap_user->getFirstAttribute('displayname') . ' has been synced successfully!']);
                return redirect('/');
            } else {
                session(['synced' => $ldap_user->getFirstAttribute('displayname') . ' is already synced!']);
                return redirect('/');
            }
        }

        return redirect('/');
    }

    public function checkPosix($ldap_user): bool
    {
        if (in_array('posixAccount', $ldap_user->objectclass)) {
            return true;
        } else {
            return false;
        }
    }

    public function getUidNumber()
    {
        if (config('sync.synology'))
        {
            $uid = Entry::find('cn=curID,cn=synoconf,{base}');
            $uid->setAttribute('uidnumber', $uid->getFirstAttribute('uidnumber') + 1);
            try {
                $uid->save();
            } catch (LdapRecordException $e) {
//                session()->flash('error', $e->getMessage());
                dd($e->getMessage());
            }
            return $uid->getFirstAttribute('uidnumber') - 1;
        } else {
            return User::where('uidnumber', '>=', 1000000)->orderBy('uidnumber', 'desc')->first()->getFirstAttribute('uidnumber') + 1;
        }
    }

    /**
     * @param Collection|User|Model $ldap_user
     * @return void
     * @throws LdapRecordException
     * @throws ModelDoesNotExistException
     */
    public function updateGroup(Collection|User|Model $ldap_user): void
    {
//                $old = Group::find('cn=' . config('sync.default_group') . ',cn=groups,{base}');
        $old = Group::where('cn', config('sync.default_group'))->first();
        $members = $old->getAttribute('member');
        $memberuids = $old->getAttribute('memberuid');
        $memberuid = $ldap_user->getFirstAttribute('uid');
//        TODO: check if memberuid or member is empty
//        TODO: check if memberuid or member is being used by LDAP/keycloak (config option)
        $old->updateAttribute('member', array_slice($members, 0, array_search($ldap_user->getDn(), $members)));
//        $old->updateAttribute('memberuid', array_slice($memberuids, 0, array_search($memberuid, $memberuids)));

//        $new = Group::find($ldap_user->getFirstAttribute('memberof'));
        $new = Group::find('cn=users,cn=groups,{base}');
        $new->setAttribute('memberuid', array_merge($new->getAttribute('memberuid'), [$memberuid]));
        $new->setAttribute('member', array_merge($new->getAttribute('member'), [$ldap_user->getDn()]));
        $new->save();
    }

    public function checkUserExists($dn)
    {
//        if(User::find($dn)->exists())
//        {
//            return User::find($dn);
//        }
//        return User::find($dn);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return View
     */
    public function render()
    {
        return view('livewire.sync-ldap');
    }


}
