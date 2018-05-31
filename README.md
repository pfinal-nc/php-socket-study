# PHP-SOCKET-STUDY  

### TCP 协议了解

> TCP（Transmission Control Protocol 传输控制协议）是一种面向连接的、可靠的、基于字节流的传输层通信协议，由IETF的RFC 793定义。当应用层向TCP层发送用于网间传输的、用8位字节表示的数据流，TCP则把数据流分割成适当长度的报文段，最大传输段大小（MSS）通常受该计算机连接的网络的数据链路层的最大传送单元（MTU）限制。之后TCP把数据包传给IP层，由它来通过网络将包传送给接收端实体的TCP层。

> TCP是因特网中的传输层协议，使用三次握手协议建立连接。当主动方发出SYN连接请求后,等待对方回答SYN+ACK,并最终对对方的 SYN 执行 ACK 确认。这种建立连接的方法可以防止产生错误的连接，TCP使用的流量控制协议是可变大小的滑动窗口协议

### Socket

> 网络上的两个程序通过一个双向的通信连接实现数据的交换，这个连接的一端称为一个socket。socket本质是编程接口(API)，对TCP/IP的封装，TCP/IP也要提供可供程序员做网络开发所用的接口，这就是Socket编程接口；HTTP是轿车，提供了封装或者显示数据的具体形式；Socket是发动机，提供了网络通信的能力。

> socket 函数应用 例如: [server.php](./code/server.php);

### Socket函数介绍

*socket_create*
```
函数原型: resource socket_create ( int domain,inttype , int $protocol )

  ● domain：AF_INET、AF_INET6、AF_UNIX，AF的释义就 address family，地址族的意思
  
  ● type: SOCK_STREAM、SOCK_DGRAM等，最常用的就是SOCK_STREAM，基于字节流的SOCKET类型，也是TCP协议使用的类型
  
  ● protocol: SOL_TCP、SOL_UDP
```  
*socket_bind*

```
函数原型: bool socket_bind ( resource socket,stringaddress [, int $port = 0 ] )
  
  ● socket: 使用socket_create创建的socket资源
  
  ● address: ip地址
  
  ● port: 监听的端口号，WEB服务器通常为80端口
  
```
*socket_listen*

```
函数原型: bool socket_listen ( resource socket[,intbacklog = 0 ] )
  
  ● socket: 使用socket_create创建的socket资源
  
  ● backlog: 等待处理连接队列的最大长度
  
```
*stream_socket_server*

```
由于创建一个SOCKET的流程总是 socket、bind、listen，所以PHP提供了一个非常方便的函数一次性创建、绑定端口、监听端口
函数原型: resource stream_socket_server ( string $local_socket [, int &$errno [, string &$errstr [, int $flags = STREAM_SERVER_BIND | STREAM_SERVER_LISTEN [, resource $context ]]]] )
  ● local_socket: 协议名://地址:端口号
  ● errno: 错误码
  ● errstr: 错误信息
  ● flags: 只使用该函数的部分功能
  ● context: 使用stream_context_create函数创建的资源流上下文
```

*socket_accept*

```
函数原型: resource socket_accept ( resource $socket )
  ● socket: 使用socket_create创建的socket资源
stream_socket_accept
函数原型: resource stream_socket_accept ( resource servers​ocket[,floattimeout = ini_get("default_socket_timeout") [, string &$peername ]] )
  ● server_socket: 使用stream_socket_server创建的stream资源
  ● timeout: 超时时间
  ● peername: 设置客户端主机名称
```

*socket_write*

```
函数原型: int socket_write ( resource socket,stringbuffer [, int $length ] )
  ● socket: 调用socket_accept接受的新连接产生的socket资源
  ● buffer: 写入到socket资源中的数据
  ● length: 控制写入到socket资源中的buffer的长度，如果长度大于buffer的容量，则取buffer的容量
```

*socket_close*

```
函数原型: void socket_close ( resource $socket )
  ● socket: socket_accept或者socket_create产生的资源，不能用于stream资源的关闭
```

*pcntl_fork*

```
函数原型: int pcntl_fork ( void )
执行该函数，会复制当前进程产生另一个进程，称之为当前进程的子进程，该函数在父进程和子进程的返回值不相同，在父进程中返回的是fork出的子进程的进程ID，而在子进程中返回值为0。
要注意的是在复制进程时，会复制该进程的数据（堆数据、栈数据和静态数据），包括在父进程打开的文件描述符，在子进程中也是打开的，这意味着当你在父进程使用了大量内存时，fork出来的子进程必须拥有等量的内存资源，否则可能会导致fork失败.

```
*pcntl_waitpid*

```
函数原型: int pcntl_waitpid ( int $pid , int &$status [, int $options = 0 ] )
● pid: 进程ID
● status: 子进程的退出状态
● option: 取决于操作系统是否提供wait3函数，如果提供该函数，则该选项参数才生效.
```