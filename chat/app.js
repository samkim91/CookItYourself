// 설치한 express 모듈 불러오기 express란 nodeJs 의 웹프레임워크로 웹서버에 필요한 라우터, 세션관리 등을 설정하는데 도움을 줌
const express = require('express')

// 설치한 socket.io 모듈 불러오기 socket.io는 실시간 웹 애플리케이션을 위한 JavaScript 라이브러리이다. 웹 클라이언트와 서버간의 양방향 통신을 가능하게 함
// 브라우저에서 실행되는 클라이언트 측 라이브러리와 nodeJs 용 서버 측 라이브러리의 두 부분으로 구성됨. 이 두 컴포넌트들은 거의 동일한 API를 가졌다. nodeJs와 같이 이벤트 기반이다.
// socket 이란 컴퓨터 네트워크를 경유하는 프로세스 간 통신의 종착점이다. 오늘날엔 대부분 인터넷 소켓임. 네트워크 통신을 위한 프로그램들은 소켓을 생성하고, 이 소켓을 통해서 데이터를 주고 받음
// socket 은 인터넷 프로토콜(TCP, UDP, raw IP), 로컬 ip 주소, 로컬 포트, 원격 ip주소, 원격 포트 등의 요소로 구성되어 있음. 인터넷 소켓은 UDP TCP 두 가지 타입으로 분류할 수 있음.
const socket = require('socket.io')

// nodeJs의 기본 내장 모듈 불러오기
const http = require('http')

// nodeJs의 기본 내장 모듈 불러오기. fs는 파일과 관련된 처리를 할 수 있음.
const fs = require('fs')

// express 객체 생성
const app = express()

// express http 서버 생성
// server 란 클라이언트에게 네트워크를 통해 정보나 서비스를 제공하는 컴퓨터 시스템으로 컴퓨터 프로그램 또는 장치를 의미한다.
const server = http.createServer(app)

// 생성된 서버를 socket.io에 바인딩 한다.
const io = socket(server)

// 정적파일을 제공하기 위해 미들웨어(Middleware)를 사용하는 코드이다. 원하는 미들웨어는 더 추가할 수 있다.
// 미들웨어란 양쪽을 연결하여 데이터를 주고 받을 수 있도록 중간 매개 역할을 하는 소프트웨어, 네트워크를 통해서 연결된 여러 개의 컴퓨터에 있는 많은 프로세스들에게 어떤 서비스를
// 사용할 수 있도록 연결해주는 소프트웨어를 말함.
app.use('/css', express.static('./static/css'))
app.use('/js', express.static('./static/js'))

// get 방식으로 / 경로에 접속하면 실행됨. 안에 있는 함수는 request, response 매개변수를 받는다.
// request는 클라이언트에서 전달된 데이터와 정보들을 담고, response는 클라이언트에게 응답하기 위한 정보들을 담는다.
app.get('/', function(request, response){
  // 지정한 파일을 읽어온다. 에러가 나면 '에러'를 보냄
  fs.readFile('./static/index.html', function(err, data){
    if(err){
      response.send('에러')
    }else{
      // 에러가 안 나면, 헤더에 html 파일이라는 것을 알려줌. 200은 statusCode로 OK라는 뜻을 가짐
      response.writeHead(200, {'Content-Type':'text/html'})
      // 데이터를 보내고
      response.write(data)
      // 모두 보냈으면 완료되었음을 알린다.(write를 통해 응답할 경우 반드시 end를 사용해줘야함.)
      response.end()
    }
  })
  // 전달할 데이터를 send()를 통해 전달하면 서버가 클라이언트(앱)로 데이터를 돌려줌.
  // response.send('Hello, Express Server!!')
})

// on()은 소켓에서 해당 이벤트를 받으면 콜백함수가 실행됨. 즉 여기선 connection이라는 이벤트가 발생할 경우 콜백 함수가 실행됨.
// io.socket 은 접속되는 모든 소켓들을 의미한다.
// 여기서 접속과 동시에 콜백함수로 전달되는 소켓은 접속된 해당 소켓이다.
io.sockets.on('connection', function(socket){
  // console.log('유저 접속됨')

  // 새로운 유저가 접속했을 경우 다른 소켓에게도 알려줌
  // 클라이언트가 접속을 하면 newUser 이벤트를 발생시킨다. 이 때 유저 닉네임도 같이 서버로 전송하여 소켓 안에 이름을 저장해둔다.
  socket.on('newUser', function(name){
    console.log(name + ' 님이 접속하였습니다.')

    // 소켓에 이름 저장하기
    socket.name = name

    // emit을 통해 모든 소켓에게 전송(다른 유저들도 알 수 있도록 하는 것)
    io.sockets.emit('update', {type: 'connect', name: 'SERVER', message: name + ' 님이 접속하였습니다.'})
  })

  // 전송한 메시지 받기
  socket.on('message', function(data){
    // 받은 데이터에 누가 보냈는지 이름 추가(위에서 소켓에 저장해둔 이름을 사용한다.)
    data.name = socket.name

    console.log(data)

    // 보낸 사람을 제외한 나머지 유저에게 메시지를 전송한다.
    // io.sockets.emit 은 나를 포함한 전체를 대상으로 하고, socket.broadcast.emit은 나를 제외한 전체를 대상으로 한다.
    socket.broadcast.emit('update', data)
  })
  // 콜백함수 안에서 해당 소켓과 통신할 코드를 작성하면 된다.
  // 아래 코드는 send라는 이벤트를 받을 때 호출되는 것임.
  // socket.on('send', function(data){
    // console.log('전달된 메시지:', data.msg)
  // })
  // disconnect 이벤트(socket.io 기본 이벤트)를 받을 때 실행되는 것임. 연결되어 있던 소켓과 접속이 끊어지면 자동으로 실행됨.
  socket.on('disconnect', function(){
    // console.log('접속 종료')
    console.log(socket.name + ' 님이 나갔습니다.')

    // 나가는 사람을 제외한 나머지 유저에게 메시지를 전송
    socket.broadcast.emit('update', {type: 'disconnect', name: 'SERVER', message: socket.name + ' 님이 나갔습니다.'})
  })
  // 위의 이벤트 이외에도 필요한 기능들을 이벤트명을 지정하여 통신할 수 있다.
})


// 서버를 8080 포트로 Listen 시키는 것.
server.listen(8080, function(){
  console.log('서버 실행중..')
})
