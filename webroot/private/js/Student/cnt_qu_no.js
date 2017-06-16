/**
 * Created by 15110014 on 2017/06/15.
 */

var count1;

window.onload = function () {
    "use strict";
    count1 = load();
    count1 ++;
    save(count1);
    document.getElementById("qaa-question-no").innerHTML =  ('問：' + count1);


    // 次の問題に遷移するボタン以外で画面遷移した場合、問題番号をリセットする
    if(!(document.getElementsByClassName("qaa-next"))){
        clear();
    }
};

location.reload = function () {
    "use strict";
    count1 = 10;
    save(count1);
};

history.back = function () {
    "use strict";
    clear();
    save(count1);
};

function load() {
    "use strict";
    var count_data = localStorage.getItem("count1");
    var count = Number(count_data);

    if(count && 1 <= count && Math.floor(count) === count ){
        return count;
    }else{
        return 0;
    }
}

function save(count) {
    "use strict";
    localStorage.setItem("count1",count);
}

function clear(){
    "use strict";
    localStorage.clear("count1");
}