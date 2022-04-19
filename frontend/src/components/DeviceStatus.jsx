import {useDeviceStatus} from "../MainServerSdk/useDeviceStatus";
import {Badge, Box, Center, Container, Flex, Text} from "@chakra-ui/react";

export function DeviceStatus() {
    const [deviceState, fetchState] = useDeviceStatus();

    if (fetchState === 'polling') {
        return (
            <Box>
                <Text fontSize={'xl'}>Loading...</Text>
            </Box>
        );
    }

    return (
        <Container
            margin={4}
            padding={4}
            border={'1px'}
            borderRadius={6}
            borderColor={'#CCC'}
            boxShadow={'md'}
        >
            <Box>
                <Flex flexDirection={'row'} justifyContent={'space-between'}>
                    <Center flex={1} justifyContent={'space-between'}>
                        <Text fontSize={'xl'}>Device Status</Text>
                        {deviceState.online ?
                            <Badge colorScheme={'green'}>Online</Badge> :
                            <Badge colorScheme={'red'}>Offline</Badge>
                        }
                    </Center>
                </Flex>
                <Text>Vacuum On: {deviceState.is_on ? 'True' : 'False'}</Text>
                <Text>Last Communication: {deviceState.last_communication_at ?? 'N/A'}</Text>
                <Text>Last Attempted Communication: {deviceState.last_communication_attempt_at ?? 'N/A'}</Text>
            </Box>
        </Container>
    )
}