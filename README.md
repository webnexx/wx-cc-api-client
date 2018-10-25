# webnexx/carcopy-api-client

a client to use the CarApi from CarCopy.com https://www.carcopy.com/fahrzeugdaten-api/

### installation

install with composer

```json
{
    "require": {
        "webnexx/carcopy-api-client": "@stable"
    }
}
```

### how to use

##### creating a client

the first step to you the CarApi client is to create a instance

```php
use CarApi\Client as CarApiClient;

// creata a valid CarApiClient Instance with your ApiKey
$client = new CarApiClient ("< YOUR API KEY >");
```

##### using the client

after creating a client, you can call the available methods

```php
$client->doVehicleFilterView()
```



### available api methods

a detailed description for the api methods can be found in the "Technisches Handbuch" PDF on our Page
https://www.carcopy.com/fahrzeugdaten-api/

here a short overview about the available functions:

**doVehicleFilterView**

to get the available vehicle data, available parameters are:

```
$filter
$fields 
$start (defaults is set to 0)
$limit (defaults is set to 30)
$order 
$orderType (defaults is set to "ASC")
```

**doVehicleFieldGroupView**

to get a grouped vehicle data item (e.q. to set them as value in a select box), available parameters are:

```
$fieldName
$filter
```

**getAvailableLanguages**

get a list of all available translations in the carapi, available parameters are:

```
$language (defaults to "de") 
```

**getAvailableValueLabels****

get a list of all available value labels with translation options, available parameters are:

```
$language (defaults to "de") 
```

**getLabelTranslations****

get a list of all available label translations, available parameters are:

```
$language (defaults to "de") 
```


**getValueTranslations****

get the translation of a specific label, available paramters are:

```
$label
$language (defaults to "de") 
```

