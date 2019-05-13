<?php
/**
 * ShortUrlMapperTest
 */
class ShortUrlMapperTest extends PHPUnit_Framework_TestCase
{
    static $pdo;

    static function setUpBeforeClass()
    {
        $pdo = self::$pdo = getPDO('test');
    }

    //テストの度にDBをクリーンな状態に戻す。
    function setUp()
    {
        $pdo = self::$pdo;
        // DB clean up
        $pdo->beginTransaction();
        $pdo->query('DELETE FROM short_url');
        $pdo->commit();
    }

    /**
     * @test
     */
    function testInsert() {

        $dbm = new ShortUrlMapper(self::$pdo);

        $data1 = new ShortUrl;
        $data1->long_url = 'http://www.yahoo.co.jp/';
        $data1->short_url = 'http://localhost:8080/cyfons/short/abb938p4mh9';
        $data1->title = 'Yahoo! JAPAN';
        $data1->group_code  = '0';
        $data1->created = new DateTime;
        $data1->end_url = 'http://localhost:8080/cyfons/';
        $data1->end_date = new DateTime;

        $dbm->insert($data1);
        $this->assertArrayHasKey('id', $data1->toArray());
    }

    /**
     * @test
     */
    function testInsertMulti() {
        $dbm = new EntryMapper(self::$pdo);

        $data1 = new ShortUrl;
        $data1->long_url = 'http://www.yahoo.co.jp/';
        $data1->short_url = 'http://localhost:8080/cyfons/short/abb938p4mh9';
        $data1->title = 'Yahoo! JAPAN';
        $data1->group_code  = '0';
        $data1->created = new DateTime;
        $data1->end_url = 'http://localhost:8080/cyfons/';
        $data1->end_date = new DateTime;

        $data2 = new ShortUrl;
        $data2->long_url = 'http://www.yahoo.co.jp/';
        $data2->short_url = 'http://localhost:8080/cyfons/short/abb938p4mh9';
        $data2->title = 'Yahoo! JAPAN';
        $data2->group_code  = '0';
        $data2->created = new DateTime;
        $data2->end_url = 'http://localhost:8080/cyfons/';
        $data2->end_date = new DateTime;

        $dbm->insert(array($data1, $data2));

        $this->assertArrayHasKey('id', $data1->toArray());
        $this->assertArrayHasKey('id', $data2->toArray());
    }

    /**
     * @test
     */
    function testUpdate() {

        $dbm = new EntryMapper(self::$pdo);

        $data1 = new ShortUrl;
        $data1->long_url = 'http://www.yahoo.co.jp/';
        $data1->short_url = 'http://localhost:8080/cyfons/short/abb938p4mh9';
        $data1->title = 'Yahoo! JAPAN';
        $data1->group_code  = '0';
        $data1->created = new DateTime;
        $data1->end_url = 'http://localhost:8080/cyfons/';
        $data1->end_date = new DateTime;

        $dbm->insert($data1);
        $this->assertArrayHasKey('entryId', $data1->toArray());

        $entry->title = 'Google';
        $data1->long_url = 'http://www.yahoo.co.jp/';
        $dbm->update($data1);

        //DBに保存されたか確かめるため、fetchしなおす
        $data1 = $dbm->find($data1->id);
        $this->assertSame('Google', $data1->title);
        $this->assertSame('http://www.yahoo.co.jp/', $data1->long_url);
    }

    /**
     * @test
     */
    function testDelete() {

        $data1 = new ShortUrl;
        $data1->long_url = 'http://www.yahoo.co.jp/';
        $data1->short_url = 'http://localhost:8080/cyfons/short/abb938p4mh9';
        $data1->title = 'Yahoo! JAPAN';
        $data1->group_code  = '0';
        $data1->created = new DateTime;
        $data1->end_url = 'http://localhost:8080/cyfons/';
        $data1->end_date = new DateTime;

        $dbm = new EntryMapper(self::$pdo);

        $dbm->insert($entry);
        $dbm->delete($entry);

        $records = $dbm->findAll()->fetchAll();

        $this->assertEmpty($records);
    }
}
