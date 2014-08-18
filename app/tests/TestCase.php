<?php

class TestCase extends Illuminate\Foundation\Testing\TestCase {

    /**
     * DB利用flag
     */
    protected $useDB = true;

    /**
  	 * Creates the application.
  	 *
  	 * @return \Symfony\Component\HttpKernel\HttpKernelInterface
  	 */
    public function createApplication()
    {
        $unitTesting = true;

        $testEnvironment = 'testing';

        return require __DIR__.'/../../bootstrap/start.php';
    }

    public function setUp()
    {
        parent::setUp();

        //DB初期化処理
        if ($this->useDB) {
            $this->setUpDB();
        }

    }

    protected function setUpDB()
    {
        //DB作成
        Artisan::call('migrate');
        //テストデータ登録
        $this->seed();
    }

}
