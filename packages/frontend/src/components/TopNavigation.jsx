import {Box, Flex, Icon, IconButton, Link, Spacer, Text} from "@chakra-ui/react";
import {GoMarkGithub} from "react-icons/go";

export function TopNavigation() {
    return (
        <nav>
            <Box backgroundColor={'#00ba9b'} p={2}>
                <Flex flexGrow={1} direction={'row'}>
                    <Box alignSelf={"center"}>
                        <Text fontSize={'xx-large'} fontWeight={'bold'}>Vacuum Status</Text>
                    </Box>
                    <Spacer/>
                    <Box alignSelf={"center"}>
                        <Link href={'https://github.com/iPwnPancakes/Fullstack-GPIO'} isExternal>
                            <IconButton
                                aria-label={'Go to project on github'}
                                icon={<Icon as={GoMarkGithub} fontSize={'x-large'}/>}
                                isRound
                            />
                        </Link>
                    </Box>
                </Flex>
            </Box>
        </nav>
    )
}