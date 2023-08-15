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