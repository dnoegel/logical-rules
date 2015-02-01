# Rules
Rules is a simple PHP library which allows you to check nested logical rules. They might come in handy if you need to check user generated rulesets automatically.

# Available rules

"Rules" knows two different rule types. Containers (logical operators/junctions) and rules (logical operands).

Container rules:

 * AND
 * OR
 * XOR
 * NOT

rules:

 * True
 * False

Of course you can add your own rules like "User older 18".

# Using the rules

## Instantiation

You can simply instantiate your rules and nest them like this:

    $rule = new AndRule(
        new TrueRule(),
        new OrRule(
            new FalseRule(),
            new TrueRule()
        ),
        new NotRule(
            new FalseRule()
        )
    );

    $rule->validate();

This will return "true" as the logical expression

    true AND (false OR true) AND NOT false

is true.

## RuleBuilder

In many cases you want to generate your logical tree from an existing data structure. For this you can use the RuleBuilder:

    $builder = new RuleBuilder(new RuleRegistry());

    $result = $builder->fromArray(array(
        'and' => array(
            new TrueRule(),
            new TrueRule()
        ),
        'or' => array(
            'false',
            new TrueRule()
        )
    ));

Using the fromArray() method of the RuleBuilder you are able to pass your rules as a nested array. The rules can be passed by reference (e.g. new TrueRule()) or by name (e.g. "false"). Any sub-array will result in a new container rule from the type of the array key:

    array(
        'and' => array()
    )

will create a AND container. The above call will result in this rule:

    (true AND true) AND (false OR true)

The fromArray() method has a second optional parameter "containerType". By default this is AND. So the logical elements on the first level will be linked with AND.

# Own rules

You can create own rules quite simple. For containers you should implement the "container" interface, for simple rules the "rule" interface.

    class UserAgeRule implements Rule
    {
        protected $user;
        public function __construct($user)
        {
            $this->user = $user;
        }

        public function validate()
        {
            return $this->user->getAge() >= 21;
        }
    }


Use this as follows:

    $rule = new AndRule(array(
        new UserAgeRule($currentUser),
        new SomeOtherRule()
    ))
    $rule->validate();

So in order to pass current context information to your rule, you should use the constructor of that rule. If you want your rules to be supported by the RuleBuilder, you should register them to the RuleRegistry:

    $registry = new RuleRegistry();
    $registry->add('age', new UserAgeRule($currentUser));
    $registry->add('someOtherRule', new SomeOtherRule());

    $builder = new RuleBuilder($registry);
    $rule = $builder->fromArray(array(
        'age',
        'someOtherRule'
    ));
    $rule->validate();

## Rule configuration

Especially if the rules are somehow user generated, you might need some additional configuration. So instead of having a "user is older then 18" rule, you want a "user is older then X" rule.
While this is no problem when instantiating the rule objects manually, you might want to have a way, to automatically configure your rule from within the fromArray() method.

For this you can implement the ConfigAware interface:

    class MinimumAgeRule implements Rule, ConfigAware
    {
        protected $user;
        protected $minAge;

        public function __construct($user)
        {
            $this->user = $user;
        }

        public function setConfig($config)
        {
            $this->minAge = $config;
        }

        public function validate()
        {
            return $this->user->getAge() >= $this->minAge;
        }
    }


Now you are able to configure your rules like this:

    $registry = new RuleRegistry();
    $registry->add('minimumAge', new MinimumAgeRule($currentUser));
    $registry->add('someOtherRule', new SomeOtherRule());

    $builder = new RuleBuilder($registry);
    $rule = $builder->fromArray(array(
        'minimumAge' => 21,
        'maximumAge' => 44
    ));
    $rule->validate();

