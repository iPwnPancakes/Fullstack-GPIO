import {useMainServer} from './MainServerSdk/useMainServer';
import {Badge, Center, Container, Flex, Stack, Text} from "@chakra-ui/react";
import {DeviceStatus} from "./components/DeviceStatus";
import {TopNavigation} from "./components/TopNavigation";

function App() {
    const [isOnline, fetchState, error] = useMainServer();

    return (
        <>
            <TopNavigation/>
            <Container>
                <Stack spacing={4} align={"stretch"}>

                    <Container>
                        <Flex flexDirection={'row'}>
                            <Text fontSize={'xl'}>Main Server Status: </Text>
                            <Center>
                                {fetchState === 'initial' ? <Badge>Loading</Badge> : null}
                                {error ? <Badge colorScheme={'red'}>Down</Badge> : null}
                                {isOnline ? <Badge colorScheme={'green'}>Online</Badge> : null}
                            </Center>
                        </Flex>
                    </Container>

                    {isOnline ? <DeviceStatus/> : null}
                </Stack>
            </Container>
        </>
    );
}

export default App;
