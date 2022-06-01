# ServerAllocation

- This subject is about to create a host, run one or more virtual servers on the host and web applications on each virtual server.
- The computerspecifications of the servers/apps are based on CPU, RAM, NIC.
- It fits as long as there is space in its dependent system.

## Algorithm
- The algorithm is based on "first fit".

## Config.php
- Check the config.php file to switch for a debug level between 0 and 3
- Change the Test by the Enum. Possible Options: Test::Dynamic or Test::Static 

### Dynamic Test
- The runDynamicTest.php uses objects based on different values of their arguments.
- It tries to Insert all WebApplications which fits into a virtual server.

### Static Test
- The runDynamicTest.php uses objects based on same values of their arguments.
- It tries to insert all dependent systems.

# NOTE: the tests are not completed yet.
