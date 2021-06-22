import {useEffect, useState} from 'react';
import {SDK} from './src';

export function useMainServer() {
    const [isOnline, setIsOnline] = useState(false);
    const [fetchState, setFetchState] = useState('initial');
    const [error, setError] = useState(null);

    useEffect(() => {
        const interval = setInterval(() => {
            setFetchState('polling');

            SDK.GetDeviceState(1)
                .then(() => {
                    setError(null);
                    setIsOnline(true);
                })
                .catch((e) => {
                    setError(e ?? 'Unspecified Error');
                    setIsOnline(false);
                })
                .finally(() => {
                    setFetchState('done');
                });
        }, 3000);

        return function cleanup() {
            clearInterval(interval);
        };
    }, []);

    return [isOnline, fetchState, error];
}
