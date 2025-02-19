<?php
namespace Services;
use Repositories\CreateAccountRepository;

class CreateAccountService {
    public function insert($account) {
        // retrieve data
        $repository = new CreateAccountRepository();
        $repository->insert($account);        
    }
}
?>