/**
 * Created by 15110014 on 2017/06/15.
 */

window.onload = function () {
    "use strict";
    var count1 = load();
    count1 ++;
    save(count1);
    document.getElementById("qaa-question-no").innerHTML = count1;
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