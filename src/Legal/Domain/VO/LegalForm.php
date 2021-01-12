<?php
declare(strict_types=1);

namespace Legal\Domain\VO;


use Legal\Domain\Exception\LegalForm\EmptyLegalFormException;

final class LegalForm
{
    const STATE = 'государственная';
    const PRIVATE = 'частная';

    private string $legalForm;

    public function __construct(string $legalForm)
    {
        if (empty($legalForm)) {
            throw new EmptyLegalFormException($legalForm);
        }

        $this->legalForm = $legalForm;
    }
    /**
     * @return string
     */
    public function getLegalForm(): string
    {
        return $this->legalForm;
    }

    public function getPrivateOrState(): string
    {
        $privateFormArray = [
            'ИП',
            'индивидуальный предприниматель',
            'ООО',
            'общество с ограниченной ответственностью',
            'ОДО',
            'общество с дополнительной ответственностью',
            'ОАО',
            'открытое акционерное общество',
            'ЗАО',
            'закрытое акционерное общество',
            'ПК',
            'производственный кооператив',
            'КФХ',
            'крестьянское (фермерское) хозяйство',
            'ГУП',
            'государственное унитарное предприятие',
            'ОАО',
            'открытое акционерное общество',
            'ЗАО',
            'закрытое акционерное общество',
            'ПК',
            'производственный кооператив',
            'КФХ',
            'крестьянское (фермерское) хозяйство',
            'ГУП'
        ];
        if (in_array(mb_strtolower($this->legalForm), $privateFormArray)) {
            return self::PRIVATE;
        } else return self::STATE;
    }
}