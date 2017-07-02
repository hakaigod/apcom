/*jshint esversion: 6 */

test();

function test() {
	"use strict";
// WebDriver の初期化
	const webdriver = require( 'selenium-webdriver' );
// ブラウザの選択
	const foxDriver = new webdriver.Builder().forBrowser( 'firefox' ).build();

// ページタイトルの取得
	foxDriver.get( 'http://localhost:800/apcom/student/15110027/input/6/1' ).then( () => {
		foxDriver.getTitle().then( title => console.log( 'ページタイトル:', title ) );
		foxDriver.find_element_by_id( 'next_button' ).click();
	} );
	foxDriver.sleep( 1000 );
// ブラウザの終了
	foxDriver.quit();
}
