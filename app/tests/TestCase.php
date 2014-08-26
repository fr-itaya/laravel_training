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

    public function tearDown()
    {
        parent::teardown();
        //DB終期処理
        if ($this->useDB) {
            $this->tearDownDB();
        }
    }

    protected function setUpDB()
    {
        //DB作成
        Artisan::call('migrate');
        //テストデータ登録
        $this->seed();
    }

    protected function tearDownDB()
    {
        //テーブル削除
        Artisan::call('migrate:reset');
        //DBから切断(too many connections対策)
        DB::disconnect();
    }
}
