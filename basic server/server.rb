require 'socket'

server = TCPServer.open(2000)
loop {
  client = server.accept

  puts "Receiving from client"

  while (input = client.gets) && input != "\r\n"
    puts input
  end
  puts "\r\n"

  puts "Waiting from server"

  while (server_input = gets) && server_input != "\e\n"
    client.puts(server_input)
  end
  client.puts("\r\n")
  client.close
}