# Ride: ORM CLI

This module adds various ORM commands to the Ride CLI.

## Commands

### orm define

This command generates tables in the database for the defined models.

**Syntax**: ```orm define```

**Alias**: ```od```

### orm generate

This command generates the classes for all defined models.

**Syntax**: ```orm generate```

**Alias**: ```og```

### orm model
 
With this command, you can search in the available models.

**Syntax**: ```orm model [<query>]```
- ```<query>```: Query to search the models with
 
### orm model get
 
Use this command to display the definition of the provided model.

**Syntax**: ```orm model get <name>```
- ```<name>```: Name of the model

### orm entries update

This command updates all entries of a given model, changing only their dateModified.

Use this command to save all entries in bulk, regenerating the automated fields.

**Syntax**: ```orm entries update <model>```
- ```<model>```: Name of the model to update the entries from

### orm files delete

This command deletes all files on the file system which are no longer used in the models.

**Syntax**: ```orm files delete [--dry]```
- ```--dry```: Add flag to see the files which will be deleted without actually deleting them

## Related Modules 

- [ride/app](https://github.com/all-ride/ride-app)
- [ride/app-orm](https://github.com/all-ride/ride-app-orm)
- [ride/cli](https://github.com/all-ride/ride-cli)
- [ride/lib-cli](https://github.com/all-ride/ride-lib-cli)
- [ride/lib-orm](https://github.com/all-ride/ride-lib-system)

## Installation

You can use [Composer](http://getcomposer.org) to install this application.

```
composer require ride/cli-orm
```
