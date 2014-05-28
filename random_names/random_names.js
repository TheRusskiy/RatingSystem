var mysql = require('mysql');
var connection = mysql.createConnection({
    host: 'localhost',
    user: 'TheRusskiy',
    password: 'wordpass',
    database: 'diploma_development',
    charset: 'cp1251_general_ci'
});
var iconv = require('iconv-lite');
var fs = require('fs');
function to_1251(string){
//    return string;
//    var result = iconv.encode(string, 'cp1251').toString();
//    var buf = new Buffer(string, 'utf-8');
    var result = iconv.decode(string, 'utf-8');
    return result;
}
var file = fs.readFileSync("names");
var names = to_1251(file).split(/\n/);
file = fs.readFileSync("secondnames");
var secondnames = to_1251(file).split(/\n/);
file = fs.readFileSync("surnames");
var surnames= to_1251(file).split(/\n/);

function takeRandom(array){
    var index = Math.floor(Math.random() * array.length);
    return array[index];
}
connection.connect();
connection.query('SET NAMES cp1251', function(err, response){
    connection.query('SELECT * FROM staff2', function(err, rows, fields) {
        if (err) throw err;
        var changed=0;
        var people = [];
        var queries = [];
        for(var i=0; i<rows.length; i++){
            var name = (takeRandom(names));
            var surname = (takeRandom(surnames));
            var secondname = (takeRandom(secondnames));
            var shortname = name + " " + surname;
            var id = rows[i]['id'];
            var query_text = "UPDATE staff2 \
                SET name='"+name+"',  \
                surname='"+surname+"', \
                secondname='"+secondname+"', \
                shortname='"+shortname+"' \
                WHERE id="+id+" \
                ";
            queries[i]=query_text;
            connection.query(query_text, function (err, response) {
                        if (err){
                            console.log(err);
                            console.log(queries[changed]);
                            throw err;
                        }
                        changed++;
                        console.log("Changed: "+changed+"/"+rows.length);
                    })
        }
        connection.end();
    });

});