<?php

/**
 * Created by PhpStorm.
 * User: tookuk
 * Date: 16.06.15
 * Time: 21:55
 */
class Item
{


    var $type;
    var $description;
    var $status;
    var $user;
    var $photopath;


    public function __construct()
    {
        $this->type = 'Привод';
        $this->description = '

                            <ul>
                                <li>В качестве основного разрешены все образцы, не противоречащие правилам Страйкбола,
                                    каждый член
                                    Команды выбирает себе оружие исходя из личных предпочтений строго АК серии
                                </li>
                                <li>В качестве вторичного оружия является пистолет трёх модификаций принятых на Совете
                                    Команды
                                </li>
                                <li>Обязательным оружием члена команды является основное оружие – копия реально существующих
                                    образцов.
                                </li>
                                <li>Автоматическое оружие/пулемёты и снайперские винтовки - должны иметь внешнее сходство с
                                    образцами,
                                    используемыми в современной Российской армии.
                                </li>
                                <li>Оружие используется с механическими обоймами исключение только на пулемёты и снайперские
                                    винтовки.
                                </li>
                            </ul>
                            ';
        $this->status = 'HAVE';
    }

    public function displayAsBlock()
    {
        echo '

<div class="container itemblock">
<legend style="border-bottom: 1px solid #000000; font-weight: bold;">' . $this->type . '</legend>
<div class="row">
<div class="col-md-8">
<form class="form-horizontal">
    <fieldset>
    <!-- Form Name -->
        <!-- Multiple Radios -->
        <div class="form-group">
          <label class="col-md-4 control-label" for="radios">Отметка о владении</label>
          <div class="col-md-4">
          <div class="radio">
            <label for="status_radio_have">
              <input type="radio" name="radios" id="status_radio_have" value="1" checked="checked">
              Имею
            </label>
            </div>
          <div class="radio" style="width:380px">
            <label for="radios-1">
              <input type="radio" name="radios" id="radios-1" value="2">
              Собираюсь приобрести
            </label>
            </div>

            <div class="radio">
            <label for="radios-2">
              <input type="radio" name="radios" id="radios-2" value="3">
              Не собираюсь использовать
            </label>
            </div>

          </div>
        </div>

        <!-- Textarea -->
        <div class="form-group">
          <label class="col-md-4 control-label" for="textarea">Описание/комментарий</label>
          <div class="col-md-4">
            <textarea class="form-control" id="textarea" name="textarea"></textarea>
          </div>
        </div>

    </fieldset>
</form>
</div>
<div class="col-md-4">

</div>
</div>
<div class="row">
    <div class="col-md-12">
        <p>'.$this->description.'</p>
    </div>
</div>
</div>
            ';
    }


}