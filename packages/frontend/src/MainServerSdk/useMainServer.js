import { useEffect, useState } from 'react';
import { makeSdk } from './src';

export function useMainServer() {
    const [isOnline, setIsOnline] = useState(false);
    const [isLoading, setIsLoading] = useState(true);
    const [errors, setError] = useState(null);
    const [deviceStatus, setDeviceStatus] = useState({
        online: false,
        is_on: false,
        last_communication_time: null,
    });

    useEffect(() => {
        const sdk = makeSdk();

        const interval = setInterval(() => {
            setIsLoading(true);

            sdk.GetDeviceState(1)
                .then(({ connected, last_communication_at, last_communication_attempt_at, is_on }) => {
                    setError(null);
                    setDeviceStatus({
                        online: connected,
                        is_on: is_on,
                        last_communication_time: last_communication_at,
                    });
                    setIsOnline(true);
                })
                .catch((e) => {
                    setIsOnline(false);

                    if (e) {
                        setError(e);
                    }
                })
                .finally(() => {
                    setIsLoading(false);
                });
        }, 3000);

        return function cleanup() {
            clearInterval(interval);
        };
    }, []);

    return [isOnline, isLoading, deviceStatus, errors];
}
