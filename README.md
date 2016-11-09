# Clay

Clay allows you to populate a model object with an array of data (from a database or other data store) without having to
manually apply the values by hand. Data is applied to the model based on the name of each property, either directly or via setters if they are available.
Clay supports nested array data and properties which contain other objects (in a multi layered data structure) as well as
automatically converting keys to camel case when applying data to the model.

## installation

Install via composer

    composer require downsider/clay

## Simple Example

To use Clay, a model should use the ModelTrait trait and implement a method which calls loadData()

    class Model
    {
        use Downsider\Clay\Model\ModelTrait;
    
        public $property;
        ...

        public function __construct(array $data = [])
        {
            $this->loadData($data);
        }

    }

The model can then be instantiated, passing data to the constructor

    $data = ["property" => "value", ...];
    $model = new Model($data);

    echo $model->property; // outputs "value"

Data with underscored or spaced keys will be applied to their camel case counterparts:

    $data = [
        "long_field_name" => ... // will apply to the property "longFieldName"
        "property name with spaces" => ... // will apply to "propertyNameWithspaces"
    ];


## Object instantiation

If you want a subset of the data to be contained within a second class, you simply need to type-hint the
supplied argument in a setter

    class Address
    {
        use Downsider\Clay\Model\ModelTrait;

        public $street;
        public $city;

        public function __construct(array $data = [])
        {
            $this->loadData($data);
        }
    }

    class Customer
    {
        use Downsider\Clay\Model\ModelTrait;
    
        protected $address;
    
        public function __construct(array $data = [])
        {
            $this->loadData($data);
        }
    
        public function setAddress(Address $address)
        {
            $this->address = $address;
        }
    
    }

    $data = [
        "address": [
            "street" => "1 test street",
            "city" => "exampleton"
        ]
    ]

    $customer = new Customer($data);
    echo $customer->getAddress()->city; // outputs "exampleton"

## Object collections

The same can be done for an array or collection of objects. Clay looks for an "add" method for that property to
determine the class to instantiate

    class Customer
    {
        use Downsider\Clay\Model\ModelTrait;
    
        protected $addresses = [];
    
        public function __construct(array $data = [])
        {
            $this->loadData($data);
        }
    
        public function setAddresses(array $addresses)
        {
            $this->addresses = [];
            foreach ($addresses as $address) {
                $this->addAddresses($address));
            }
        }
    
        public function addAddresses(Address $address)
        {
            $this->addresses[] = $address;
        }
    
    }
    
    $data = [
        "addresses": [
            [
                "street" => "1 Test street",
                "city" => "Exampleton"
            ],
            [
                "street" => "22 Sample row",
                "city" => "Testville"
            ]
        ]
    ]
    
    $customer = new Customer($data);
