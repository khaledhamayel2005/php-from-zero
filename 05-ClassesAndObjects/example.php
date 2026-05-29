<?php
// Example: Classes and Objects in PHP
// A simple class with private properties and public methods.

class Person {
    // Private properties hold the object's internal state.
    private string $name;
    private int $age;

    // Constructor initializes the object when created.
    public function __construct(string $name, int $age) {
        $this->name = $name;
        $this->age = $age;
    }

    // Public getter for the name property.
    public function getName(): string {
        return $this->name;
    }

    // Public getter for the age property.
    public function getAge(): int {
        return $this->age;
    }

    // A method that describes the person.
    public function greet(): string {
        return "Hi, I'm " . $this->name . " and I'm " . $this->age . " years old.";
    }
}

// Inheritance: Student extends Person and adds a new property.
class Student extends Person {
    private string $school;

    public function __construct(string $name, int $age, string $school) {
        // Call parent constructor to set name and age.
        parent::__construct($name, $age);
        $this->school = $school;
    }

    // Override greet() to include school information.
    public function greet(): string {
        // Use parent's getters to access protected data through public API.
        return parent::greet() . " I study at " . $this->school . ".";
    }
}

// Usage examples
$person = new Person('Ali', 30);
echo $person->greet() . PHP_EOL; // Calls Person::greet()

$student = new Student('Sara', 22, 'University of Cairo');
echo $student->greet() . PHP_EOL; // Calls Student::greet() (overridden)

// Notes:
// - Properties are private to encapsulate state.
// - Use public methods (getters/setters) to interact with object state.
// - Create objects with `new ClassName(...)` and call methods with `->`.
