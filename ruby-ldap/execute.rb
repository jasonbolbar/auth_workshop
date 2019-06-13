require 'net/ldap'
require 'io/console'

puts '*****************************************'
puts '*                                       *'
puts '*                                       *'
puts '*          LDAP AUTHENTICATION          *'
puts '*                                       *'
puts '*                                       *'
puts '*****************************************'

puts 'Enter Username'
username = gets.chop
password = IO::console.getpass "Enter Password: "



ldap = Net::LDAP.new
ldap.host = '10.10.10.21'
ldap.port = 389
ldap.auth username, password

puts ldap.bind ? 'User Authenticated' : 'User Not Authenticated'