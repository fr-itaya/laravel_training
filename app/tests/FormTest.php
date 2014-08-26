<?php

class FormTest extends TestCase {

    public function testViewHasPrefValue()
    {
        $this->action('GET', 'FormController@getForm');
        $this->assertViewHas('data');
    }
}
