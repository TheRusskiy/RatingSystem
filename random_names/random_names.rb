require 'mysql2'
require 'awesome_print'
client = Mysql2::Client.new(
	host: "localhost", 
	username: "root", 
	socket: '/tmp/mysql.sock', 
	database: 'diploma_development')
client.query("SET NAMES cp1251")
results = client.query("SELECT * FROM staff2")
ids = []
results.each do |r|
	ids << r["id"]
end
file = File.open('names')
names = file.to_a.map{|n| n.delete("\n")}
file = File.open('secondnames')
secondnames = file.to_a.map{|n| n.delete("\n")}
file = File.open('surnames')
surnames = file.to_a.map{|n| n.delete("\n")}

ids.each_with_index do |id, i|
	puts "#{i+1}/#{ids.length}"
	name = names.sample
	surname = surnames.sample
	secondname = secondnames.sample
	shortname = "#{name} #{surname}"
	client.query("UPDATE staff2 \
		SET name='#{name}', \
		surname='#{surname}', \
		secondname='#{secondname}', \
		shortname='#{shortname}' \
		WHERE id=#{id}
		")
end