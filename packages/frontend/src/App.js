import {useMainServer} from './MainServerSdk/useMainServer';

function App() {
    const [isOnline, isLoading, deviceStatus] = useMainServer();

    return (
        <div className='App'>
            <header className='App-header'>
                <h1>Main Server Status</h1>
                <p>Is Loading: {isLoading.toString()}</p>
                <p>Is Online: {isOnline.toString()}</p>

                {!isOnline ? null : (
                    <>
                        <h1>Device Status</h1>
                        <p>Online: {deviceStatus.online.toString()}</p>
                        <p>Is On: {deviceStatus.is_on.toString()}</p>
                        <p>Last Communication: {deviceStatus.last_communication_time.toString()}</p>
                    </>
                )}
            </header>
        </div>
    );
}

export default App;
