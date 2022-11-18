<?php

namespace Scopeli\FlowBundle;

use Scopeli\FlowBundle\Element\Bpmn;
use Scopeli\FlowBundle\Process\ProcessDefinitionRepository;

trait ProcessDefinitionRepositoryTrait
{
    private ?ProcessDefinitionRepository $processDefinitionRepository = null;

    private function getProcessDefinitionRepository(?string $folder = null): ProcessDefinitionRepository
    {
        if (null === $folder) {
            $folder = sprintf('%s/Resources/bpmn', __DIR__);
        }

        $bpmnFiles = glob(sprintf('%s/*.bpmn', $folder));

        $buffer = [];
        foreach ($bpmnFiles as $bpmnFile) {
            $bpmnParts = pathinfo($bpmnFile);
            $buffer[$bpmnParts['filename']] = file_get_contents($bpmnFile);
        }

        return new ProcessDefinitionRepository($buffer);
    }

    private function initProcessDefinitionRepository(?string $folder = null)
    {
        $this->processDefinitionRepository = $this->getProcessDefinitionRepository($folder);
    }

    private function getBpmnString(string $id): string
    {
        if (!$this->processDefinitionRepository instanceof ProcessDefinitionRepository) {
            $this->initProcessDefinitionRepository();
        }

        return $this->processDefinitionRepository->findProcessDefinition($id);
    }

    private function getBpmn(string $id): Bpmn
    {
        $bpmn = new Bpmn();
        $bpmn->loadXML($this->getBpmnString($id));

        return $bpmn;
    }
}
