<?php
namespace MyApp;
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

class Chat implements MessageComponentInterface {
    protected $clients;
    protected $db_conn;

    public function __construct() {
        $this->clients = new \SplObjectStorage;

        $servername = "localhost";
        $username = "root"; // Update to your database username
        $password = ""; // Update to your database password
        $dbname = "test"; // Your database name

        // Create connection
        $this->db_conn = new \mysqli($servername, $username, $password, $dbname); // Note the backslash here

        // Check connection
        if ($this->db_conn->connect_error) {
            die("Connection failed: " . $this->db_conn->connect_error);
        }
    }


    public function onOpen(ConnectionInterface $conn) {
        // Store the new connection to send messages to later
        $this->clients->attach($conn);

        echo "New connection! ({$conn->resourceId})\n";
    }

    public function onMessage(ConnectionInterface $from, $msg) {
      
        $numRecv = count($this->clients) - 1;
        echo sprintf('Connection %d sending message "%s" to %d other connection%s' . "\n"
            , $from->resourceId, $msg, $numRecv, $numRecv == 1 ? '' : 's');

        foreach ($this->clients as $client) {
            if ($from !== $client) {
                // The sender is not the receiver, send to each client connected
                $client->send($msg);
            }
        }
        // Save the message to the database
        $msgData = json_decode($msg, true); // Decode the JSON data
        $name = 'Test';  // Add 'name' in the message data
        $message = $msgData['msg'];
        
        $sql = "INSERT INTO chat (name, msg) VALUES ('$name', '$message')";
        if ($this->db_conn->query($sql) === TRUE) {
            echo "Message saved to the database\n";
        } else {
            echo "Error: " . $sql . "\n" . $this->db_conn->error;
        }
    }

    public function onClose(ConnectionInterface $conn) {
        // The connection is closed, remove it, as we can no longer send it messages
        $this->clients->detach($conn);

        echo "Connection {$conn->resourceId} has disconnected\n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        echo "An error has occurred: {$e->getMessage()}\n";

        $conn->close();
    }
}