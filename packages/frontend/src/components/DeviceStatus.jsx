import {useDeviceStatus} from "../MainServerSdk/useDeviceStatus";
import {Box, Container, Text} from "@chakra-ui/react";

export function DeviceStatus() {
    const [deviceState, fetchState] = useDeviceStatus();

    if (fetchState === 'initial') {
        return (
            <Box>Loading...</Box>
        );
    }

    return (
        <Container>
            <Box>
                <Text fontSize={'xl'}>Device Status</Text>
                <Text>Online: {deviceState.online ? 'True' : 'False'}</Text>
                <Text>Vacuum On: {deviceState.is_on ? 'True' : 'False'}</Text>
                <Text>
                    Last
                    Communication: {deviceState.last_communication_time ? deviceState.last_communication_time : 'N/A'}
                </Text>
            </Box>
        </Container>
    )
}