<?php
namespace App\Service;
use App\Repository\CreateAccountRepository;

class CreateAccountService {
    public function insert($account) {
        // retrieve data
        $repository = new CreateAccountRepository();
        $repository->insert($account);        
    }
}
?>