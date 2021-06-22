import {makeGetDeviceState} from './GetDeviceState';

function makeSdk(url) {
    url = process.env.REACT_APP_MAIN_SERVER_URL;

    return {GetDeviceState: makeGetDeviceState(url)};
}

export const SDK = makeSdk(process.env.REACT_APP_MAIN_SERVER_URL);
