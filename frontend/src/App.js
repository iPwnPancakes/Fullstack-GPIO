import {Container, Stack} from "@chakra-ui/react";
import {DeviceStatus} from "./components/DeviceStatus";
import {TopNavigation} from "./components/TopNavigation";

function App() {
    return (
        <>
            <TopNavigation/>
            <Container>
                <Stack spacing={4} align={"stretch"}>
                    <DeviceStatus/>
                </Stack>
            </Container>
        </>
    );
}

export default App;
