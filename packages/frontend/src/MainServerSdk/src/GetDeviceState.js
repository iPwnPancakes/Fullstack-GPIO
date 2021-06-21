export function makeGetDeviceState(url) {
    if (!url) {
        throw new Error('URL for MainServer not specified');
    }

    return function (device_id = 1) {
        return fetch(`${url}/api/v1/frontend/getConnectionInfo/${device_id}`).then((res) => {
            try {
                return res.json();
            } catch (e) {
                return Promise.reject('Invalid response given from MainServer');
            }
        });
    };
}
