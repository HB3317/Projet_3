<?php

require_once "ContactManager.php";

class Command 
{
    private ContactManager $contactManager;

    public function __construct(ContactManager $contactManager) 
    {
        $this->contactManager = $contactManager;
    }

    public function list(): void 
    {
        $contacts = $this->contactManager->findAll();

        foreach ($contacts as $contact) {
            echo $contact->toString() . PHP_EOL;
        }
    }
}