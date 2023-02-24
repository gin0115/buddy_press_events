[![codecov](https://codecov.io/gh/gin0115/buddy_press_events/branch/main/graph/badge.svg?token=EGMRU1ANFJ)](https://codecov.io/gh/gin0115/buddy_press_events)
[![GitHub_CI](https://github.com/gin0115/buddy_press_events/actions/workflows/php.yaml/badge.svg)](https://github.com/gin0115/buddy_press_events/actions/workflows/php.yaml)

## Setting up the Dev Evnironment

This project uses PHPScoper to ensure that all the dependencies are namespaced. This means that the project can be installed as a dependency in another project without causing conflicts with other dependencies.

To set up the development environment, you will need to install the dependencies and build the project.

### Installing Dependencies

To install the dependencies, run the following command:

```bash
composer build-dev
```
This will create the dev environment and install the dependencies. 

### Building the Project

To build the project, run the following command:

```bash
composer build
```