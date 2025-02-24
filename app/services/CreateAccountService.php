<?php
namespace Services;
use Repositories\CreateAccountRepository;

class CreateAccountService {
    public function insert($user) {
        $repository = new CreateAccountRepository();
        if ($repository->checkEmail($user)){
            throw new \Exception("Email already exists");
        }
        $repository->insert($user);        
    }
}
?>