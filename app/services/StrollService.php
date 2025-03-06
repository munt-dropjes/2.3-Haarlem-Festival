<?php

namespace Services;

use Models\StrollEvent;
use Repositories\StrollRepository;

class StrollService {
    private $strollRepository;

    public function __construct() {
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

    public function getDetail($detailIndex) {
        return $this->strollRepository->getDetail($detailIndex);
    }

    public function getRoute() {
        return $this->strollRepository->getRoute();
    }

}
?>
