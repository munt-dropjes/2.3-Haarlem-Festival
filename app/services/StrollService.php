<?php

namespace Services;

use Models\StrollEvent;
use Repositories\StrollRepository;

class StrollService {
    private $strollRepository;

    private function __construct() {
        $this->strollRepository = new StrollRepository();
    }

    public function create(StrollEvent $event) {
        $this->strollRepository->create($event);
    }

    public function getAll(){
        return $this->strollRepository->getAll();
    }

    public function update(StrollEvent $event) {
        $this->strollRepository->update($event);
    }

    public function deleteStroll(StrollEvent $event) {
        $this->strollRepository->delete($event);
    }

}
?>
