import {useEffect, useState} from "react";
import {SDK} from "./src";

export function useDeviceStatus() {
    const [deviceState, setDeviceState] = useState({
        online: false,
        is_on: false,
        last_communication_time: 'N/A'
    });
    const [fetchState, setFetchState] = useState('initial');
    const [error, setError] = useState(null);

    useEffect(() => {
        const interval = setInterval(() => {
            setFetchState('polling');

            SDK.GetDeviceState(1)
                .then(({connected, last_communication_at, last_communication_attempt_at, is_on}) => {
                    setError(null);
                    setDeviceState({
                        online: connected,
                        is_on: is_on,
                        last_communication_time: last_communication_at,
                    });
                })
                .catch((e) => {
                    setError(e ?? 'Unspecified Error');
                })
                .finally(() => {
                    setFetchState('done');
                });
        }, 3000);

        return function cleanup() {
            clearInterval(interval);
        };
    }, []);

    return [deviceState, fetchState, error];
}