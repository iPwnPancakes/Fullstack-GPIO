import {useEffect, useState} from "react";
import {SDK} from "./src";
import {Websockets} from "./src/Websockets";

export function useDeviceStatus() {
    const [deviceState, setDeviceState] = useState({
        online: false,
        is_on: false,
        last_communication_at: null,
        last_communication_attempt_at: null
    });
    const [fetchState, setFetchState] = useState('polling');
    const [error, setError] = useState(null);

    useEffect(() => {
        setFetchState('polling');

        SDK.GetDeviceState(1)
            .then(({connected, last_communication_at, last_communication_attempt_at, is_on}) => {
                setError(null);
                setDeviceState({
                    online: connected,
                    is_on,
                    last_communication_at,
                    last_communication_attempt_at
                });
            })
            .catch((e) => {
                setError(e ?? 'Unspecified Error');
            })
            .finally(() => {
                setFetchState('done');
            });

        Websockets.channel('devices')
            .listen('.onCheckin', (event) => {
                setDeviceState({
                    online: true,
                    is_on: event.power_status,
                    last_communication_at: event.checkin_time
                });
            })
            .listen('.onCheckout', event => {
                setDeviceState({
                    online: false,
                    is_on: event.power_status,
                    last_communication_at: event.checkin_time
                });
            })
            .listen('.deviceCommunicationEvent', event => {
                setDeviceState({
                    online: event.connected,
                    is_on: event.power_status,
                    last_communication_at: event.checkin_time,
                    last_communication_attempt_at: event.last_communication_attempt_at
                })
            })
    }, []);

    return [deviceState, fetchState, error];
}