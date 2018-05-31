# PHP-SOCKET-STUDY  

### TCP 协议了解

> TCP（Transmission Control Protocol 传输控制协议）是一种面向连接的、可靠的、基于字节流的传输层通信协议，由IETF的RFC 793定义。当应用层向TCP层发送用于网间传输的、用8位字节表示的数据流，TCP则把数据流分割成适当长度的报文段，最大传输段大小（MSS）通常受该计算机连接的网络的数据链路层的最大传送单元（MTU）限制。之后TCP把数据包传给IP层，由它来通过网络将包传送给接收端实体的TCP层。

> TCP是因特网中的传输层协议，使用三次握手协议建立连接。当主动方发出SYN连接请求后,等待对方回答SYN+ACK,并最终对对方的 SYN 执行 ACK 确认。这种建立连接的方法可以防止产生错误的连接，TCP使用的流量控制协议是可变大小的滑动窗口协议

### Socket是什么呢？

>Socket是应用层与TCP/IP协议族通信的中间软件抽象层，它是一组接口。在设计模式中，Socket其实就是一个门面模式，它把复杂的TCP/IP协议族隐藏在Socket接口后面，对用户来说，一组简单的接口就是全部，让Socket去组织数据，以符合指定的协议。一个生活中的场景。你要打电话给一个朋友，先拨号，朋友听到电话铃声后提起电话，这时你和你的朋友就建立起了连接，就可以讲话了。等交流结束，挂断电话结束此次交谈。 生活中的场景就解释了这工作原理，也许TCP/IP协议族就是诞生于生活中，这也不一定。

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

```
socket相关函数：
----------------------------------------------------------------------------------------------
socket_accept() 接受一个Socket连接
socket_bind() 把socket绑定在一个IP地址和端口上
socket_clear_error() 清除socket的错误或者最后的错误代码
socket_close() 关闭一个socket资源
socket_connect() 开始一个socket连接
socket_create_listen() 在指定端口打开一个socket监听
socket_create_pair() 产生一对没有区别的socket到一个数组里
socket_create() 产生一个socket，相当于产生一个socket的数据结构
socket_get_option() 获取socket选项
socket_getpeername() 获取远程类似主机的ip地址
socket_getsockname() 获取本地socket的ip地址
socket_iovec_add() 添加一个新的向量到一个分散/聚合的数组
socket_iovec_alloc() 这个函数创建一个能够发送接收读写的iovec数据结构
socket_iovec_delete() 删除一个已经分配的iovec
socket_iovec_fetch() 返回指定的iovec资源的数据
socket_iovec_free() 释放一个iovec资源
socket_iovec_set() 设置iovec的数据新值
socket_last_error() 获取当前socket的最后错误代码
socket_listen() 监听由指定socket的所有连接
socket_read() 读取指定长度的数据
socket_readv() 读取从分散/聚合数组过来的数据
socket_recv() 从socket里结束数据到缓存
socket_recvfrom() 接受数据从指定的socket，如果没有指定则默认当前socket
socket_recvmsg() 从iovec里接受消息
socket_select() 多路选择
socket_send() 这个函数发送数据到已连接的socket
socket_sendmsg() 发送消息到socket
socket_sendto() 发送消息到指定地址的socket
socket_set_block() 在socket里设置为块模式
socket_set_nonblock() socket里设置为非块模式
socket_set_option() 设置socket选项
socket_shutdown() 这个函数允许你关闭读、写、或者指定的socket
socket_strerror() 返回指定错误号的详细错误
socket_write() 写数据到socket缓存
socket_writev() 写数据到分散/聚合数组
```