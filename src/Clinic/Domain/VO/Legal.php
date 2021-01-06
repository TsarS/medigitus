<?php
declare(strict_types=1);

namespace Clinic\Domain\VO;


final class Legal
{
    private string $inn;
    private string $form;

    public function __construct(
        string $inn,
        string $form)
    {

        $this->inn = $inn;
        $this->form = $form;
    }

    /**
     * @return string
     */
    public function getInn(): string
    {
        return $this->inn;
    }


    public function getCorporateForm() : string {
        // TODO Сделать проверку формы (частная/государственная)
        return $this->form;
    }
}