import {useMainServer} from './MainServerSdk/useMainServer';
import {Badge, Center, Flex, Text} from "@chakra-ui/react";
import {DeviceStatus} from "./components/DeviceStatus";

function App() {
    const [isOnline, fetchState, error] = useMainServer();

    return (
        <Center>
            <div className='App'>
                <header className='App-header'>
                    <Flex flexDirection={'row'}>
                        <Text fontSize={'xl'}>Main Server Status: </Text>
                        <Center>
                            {fetchState === 'initial' ? <Badge>Loading</Badge> : null}
                            {error ? <Badge colorScheme={'red'}>Down</Badge> : null}
                            {isOnline ? <Badge colorScheme={'green'}>Online</Badge> : null}
                        </Center>
                    </Flex>

                    {isOnline ? <DeviceStatus/> : null}
                </header>
            </div>
        </Center>
    );
}

export default App;
