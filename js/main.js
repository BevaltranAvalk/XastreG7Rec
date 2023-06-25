const { app, BrowserWindow } = require('electron');
const { spawn } = require('child_process');

let mainWindow;

function createWindow() {
  mainWindow = new BrowserWindow({
    width: 800, // Defina a largura desejada
    height: 600, // Defina a altura desejada
  });

  // Carregue o arquivo HTML do seu aplicativo
  mainWindow.loadFile('main.html');

  mainWindow.on('closed', () => {
    mainWindow = null;
  });

  // Inicie o servidor PHP embutido
  const phpServer = spawn('php', ['-S', 'localhost:80', '-t', __dirname]);

  phpServer.on('close', () => {
    // Feche a janela do Electron quando o servidor PHP for encerrado
    mainWindow.close();
  });
}

app.on('ready', createWindow);

app.on('window-all-closed', () => {
  if (process.platform !== 'darwin') {
    app.quit();
  }
});

app.on('activate', () => {
  if (mainWindow === null) {
    createWindow();
  }
});
