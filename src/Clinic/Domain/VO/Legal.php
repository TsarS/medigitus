<?php
declare(strict_types=1);

namespace Clinic\Domain\VO;


final class Legal
{
    private string $inn;
    private string $name;
    private string $form;

    public function __construct(
        string $inn,
        string $name,
        string $form)
    {

        $this->inn = $inn;
        $this->name = $name;
        $this->form = $form;
    }

    /**
     * @return string
     */
    public function getInn(): string
    {
        return $this->inn;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    public function getCorporateForm() : string {
        // TODO Сделать проверку формы (частная/государственная)
        return $this->form;
    }
}