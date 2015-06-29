# Ride: ORM CLI

This module adds various CLI commands using the ORM

## orm generate
This command generates classes for the models defined in models.xml

**alias** : og

## orm define
This command generates tables in the database for the models defined in models.xml

**alias** : od

## orm entries update
This command updates all entries of a given model, changing only their dateModified.
Use this command to do bulk changes entries which already existed before a specific change was made to their model.
