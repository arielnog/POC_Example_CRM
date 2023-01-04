<?php

namespace App\Entities;

use App\Enum\PipelineList;
use App\Enum\StageList;
use App\Enum\StatusList;
use App\Exceptions\InvalidArgumentException;
use App\ValueObjects\ContactPipeline;
use App\ValueObjects\ContactSource;
use App\ValueObjects\ContactStage;
use App\ValueObjects\ContactStatus;
use App\ValueObjects\Email;
use App\ValueObjects\Uuid;
use Exception;
use Illuminate\Http\Resources\Json\JsonResource;

class ContactEntity
{
    /**
     * @param Uuid $uuid
     * @param string $name
     * @param Email $email
     * @param ContactSource $source
     * @param ContactStage $stage
     * @param ContactStatus $status
     * @param ContactPipeline|null $pipeline
     * @param int|null $id
     */
    public function __construct(
        protected Uuid $uuid,
        protected string $name,
        protected Email $email,
        protected ContactSource $source,
        protected ContactStage $stage,
        protected ContactStatus $status,
        protected ?ContactPipeline $pipeline = null,
        protected ?int $id = null
    ) {
        $this->validate();
    }

    /**
     * @throws \Exception
     */
    private function validate()
    {
        if ($this->stage->asString() == StageList::LEAD) {
            if (!($this->pipeline?->asString() == null && $this->status->asString() == StatusList::OPEN)) {
                throw new InvalidArgumentException('Invalid Parameter');
            }
        }

        if ($this->stage->asString() == StageList::OPPORTUNITY) {
            if (!in_array($this->pipeline?->asString(), PipelineList::validStageValues())) {
                throw new InvalidArgumentException('Invalid Parameter');
            }
        }

        if ($this->stage->asString() == StageList::CUSTOMER) {
            if (!($this->pipeline?->asString() == PipelineList::WON)) {
                throw new InvalidArgumentException('Invalid Parameter');
            }
        }
    }

    /**
     * @param \App\ValueObjects\ContactPipeline|null $pipeline
     */
    public function setPipeline(?ContactPipeline $pipeline): void
    {
        $this->pipeline = $pipeline;
    }

    /**
     * @param \App\ValueObjects\ContactStage $stage
     */
    public function setStage(ContactStage $stage): void
    {
        $this->stage = $stage;
    }

    /**
     * @param \App\ValueObjects\ContactStatus $status
     */
    public function setStatus(ContactStatus $status): void
    {
        $this->status = $status;
    }

    /**
     * @param \App\ValueObjects\ContactPipeline $pipeline
     * @return void
     */
    public function updatePipeline(ContactPipeline $pipeline)
    {
        $this->setPipeline($pipeline);

        if (in_array($pipeline->asString(), PipelineList::validStageValues())) {
            $this->setStatus(ContactStatus::fromString(StatusList::IN_PROGRESS));
            $this->setStage(ContactStage::fromString(StageList::OPPORTUNITY));
        }

        if ($pipeline->asString() == PipelineList::WON) {
            $this->setStage(ContactStage::fromString(StageList::CUSTOMER));
        }
    }


    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'uuid' => $this->uuid->toString(),
            'name' => $this->name,
            'email' => $this->email->toString(),
            'source' => $this->source->asString(),
            'stage' => $this->stage->asString(),
            'status' => $this->status->asString(),
            'pipeline' => $this->pipeline?->asString(),
        ];
    }
}
