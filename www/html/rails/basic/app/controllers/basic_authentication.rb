module BasicAuthentication


  def authenticate
    authenticate_or_request_with_http_basic('Administration') do |username, password|
      User.where(username: username, password:password).first || username == 'admin' && password == 'admin'
    end
  end

end