<?php
declare(strict_types=1);

namespace Legal\Domain\VO;


use Legal\Domain\Exception\Ogrn\EmptyOgrnException;
use Legal\Domain\Exception\Ogrn\NoValiOgrnException;

final /**
 * * ОГРН (основной государственный регистрационный номер) — государственный регистрационный номер записи
 * о создании юридического лица либо записи о первом представлении в соответствии с Федеральным законом
 * Российской Федерации «О государственной регистрации юридических лиц» сведений о юридическом лице,
 * зарегистрированном до введения в действие указанного Закона (пункт 8 Правил ведения Единого
 * государственного реестра юридических лиц).
 *
 * Государственный регистрационный номер записи, вносимой в Единый государственный реестр юридических лиц,
 * состоит из 13 цифр, расположенных в следующей последовательности:
 * - С Г Г К К Н Н Х Х Х Х Х Ч
 * где:
 * - С (1-й знак) — признак отнесения государственного регистрационного номера записи:
 *   - к основному государственному регистрационному номеру (ОГРН)* — 1, 5 (присваивается юридическому лицу)
 *   - к иному государственному регистрационному номеру записи ЕГРЮЛ* (ГРН) — 2, 6, 7, 8, 9 (присваивается
 *     государственным учреждениям/образованиям)
 *   - к основному государственному регистрационному номеру индивидуального предпринимателя (ОГРНИП)* —
 *     3 (присваивается индивидуальному предпринимателю)
 *   - к иному государственному регистрационному номеру записи ЕГРИП * (ГРНИП) — 4
 *
 * В зависимости от принадлежности проставляется соответствующий номер. Юридическому лицу – цифра 1 (один),
 * индивидуальному предпринимателю – цифра 3 (три), государственным учреждениям – цифра 2 (два).
 *
 * - ГГ (со 2-го по 3-й знак) — две последние цифры года внесения записи в государственный реестр
 * - КК (4-й, 5-й знаки) — порядковый номер субъекта Российской Федерации по перечню субъектов Российской
 *   Федерации, установленному статьей 65 Конституции Российской Федерации
 * - НН (с 6-го по 7-й знак) — код налоговой инспекции
 * - ХХХХХ (с 8-го по 12-й знак) — номер записи, внесенной в государственный реестр в течение года
 * - Ч (13-й знак) — контрольное число: младший разряд остатка от деления предыдущего 12-значного числа
 *   на 11, если остаток от деления равен 10, то контрольное число равно 0 (нулю).
 * Class Ogrn
 * @package App\Legal\Domain\VO
 */
class Ogrn
{
    private string $ogrn;

    public function __construct(string $ogrn) {
        if (empty($ogrn)) {
            throw new EmptyOgrnException($ogrn);
        }
        if (!$this->validate($ogrn)) {
            throw new NoValiOgrnException($ogrn);
        }

        $this->ogrn = $ogrn;
    }

    /**
     * @return string
     */
    public function getOgrn(): string
    {
        return $this->ogrn;
    }
    private function validate($ogrn)
    {
        if (mb_strlen($ogrn) === 13) {
            return true;
        } else return false;

    }
}