import {useDeviceStatus} from "../MainServerSdk/useDeviceStatus";
import {Box, Text} from "@chakra-ui/react";

export function DeviceStatus() {
    const [deviceState, fetchState] = useDeviceStatus();

    if (fetchState === 'initial') {
        return (
            <Box>Loading</Box>
        );
    }

    return (
        <Box>
            <Text fontSize={'xl'}>Device Status</Text>
            <Text>Online: {deviceState.online.toString()}</Text>
            <Text>Vacuum On: {deviceState.is_on.toString()}</Text>
            <Text>Last Communication: {deviceState.last_communication_time.toString()}</Text>
        </Box>
    )
}