fis.match('*', {
  deploy: fis.plugin('http-push', {
    receiver: 'http://10.90.16.95:8080/fis3/tools/receiver.php',
    to: '/home/zyp/exam'// 注意这个是指的是测试机器的路径，而非本地机器
  })
});
fis.config.set("project.watch.usePolling", true);
