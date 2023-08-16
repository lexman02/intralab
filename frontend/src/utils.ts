import v8n from "v8n";

export function parseJSON(value) {
    try {
        let o = JSON.parse(value);
        if (o && typeof o === 'object') {
            return o;
        }
    } catch (e) {
        console.log(e);
        return false;
    }
}

export function validateItem(item) {
    // const urlRegex = /(https?):\/\/([A-Za-z0-9]+\.)+[a-z]+\/?/m;
    const urlRegex = /https?:\/\/(www\.)?[-a-zA-Z0-9@:%._+~#=]{1,256}\.[a-zA-Z0-9()]{1,6}\b([-a-zA-Z0-9()!@:%_+.~#?&\/=]*)/m;
    const optionalDescription = v8n().string().minLength(1).not.empty();
    const optionalIcon = v8n().string().minLength(1).not.pattern(urlRegex);
    const optionalAllowedRoles = v8n().array().every.string().minLength(1).not.empty();

    return v8n().not.empty().schema({
        name: v8n().string().minLength(1).not.empty(),
        description: v8n().optional(optionalDescription, true),
        url: v8n().string().minLength(1).pattern(urlRegex).not.empty(),
        icon: v8n().optional(optionalIcon, true),
        allowed_roles: v8n().optional(optionalAllowedRoles)
    }).test(item);
}