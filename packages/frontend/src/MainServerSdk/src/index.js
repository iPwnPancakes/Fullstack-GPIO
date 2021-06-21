import { makeGetDeviceState } from './GetDeviceState';

export function makeSdk() {
    const url = process.env.REACT_APP_MAIN_SERVER_URL;

    return { GetDeviceState: makeGetDeviceState(url) };
}
