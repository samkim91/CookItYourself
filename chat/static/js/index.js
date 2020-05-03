var socket = io()

//접속되었을 때 실행 되는 부분
socket.on('connect', function(){
  // 이름을 입력받음.. prompt는 입력값을 받는 것이다.
  var name = prompt('채팅에 사용하실 닉네임을 적어주세요.', '')

  //이름이 빈칸인 경우 익명으로 정해줌
  if(!name){
    name = "익명"
  }

  // 서버에 새로운 유저가 왔다고 알림
  socket.emit('newUser', name)

  // var input = document.getElementById('test')
  // input.value = "접속 됨"
})

// 클라이언트 측에서 받는 업데이트
socket.on('update', function(data){
  // 채팅말꼬리가 들어가는 부분
  var chat = document.getElementById('chat')

  // 추가할 채팅말꼬리를 위해 디브를 하나 만든다
  var message = document.createElement('div')

  // 위에서 만든 채팅말꼬리 디브에 내용을 넣는다.
  if(`${data.name}`=='SERVER'){
    var node = document.createTextNode(`${data.message}`)
  }else{
    var node = document.createTextNode(`${data.name}: ${data.message}`)
  }

  // 디브에 붙일 클래스네임을 선언
  var className = ''

  switch (data.type) {
    case 'message':
      className = 'other'
      break

    case 'connect':
      className = 'connect'
      break

    case 'disconnect':
      className = 'disconnect'
      break

    default:
  }

  message.classList.add(className)
  message.appendChild(node)
  chat.appendChild(message)
  // 페이지를 제일 아래로 내림(스크롤 다운)
  chat.scrollTop = chat.scrollHeight
  // console.log('${data.name}: ${data.message}')
})

//메시지를 전송하는 함수
function send(){
  //입력되어 있는 데이터 가져옴
  var message = document.getElementById('test').value

  // 입력값이 있으면 보내고 없으면 안보냄.
  if(message){
    //데이터를 가져온 뒤에 입력란을 빈칸으로 만듦
    document.getElementById('test').value = ''

    var chat = document.getElementById('chat')
    var msg = document.createElement('div')
    var node = document.createTextNode(message)
    msg.classList.add('me')
    msg.appendChild(node)
    chat.appendChild(msg)

    // 페이지를 제일 아래로 내림(스크롤 다운)
    chat.scrollTop = chat.scrollHeight
    //서버에 send 이벤트를 전달함. 이때 데이터를 포함시킴
    socket.emit('message', {type: 'message', message: message})
  }

}
