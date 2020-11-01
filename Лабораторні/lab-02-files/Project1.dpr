program Project1;

{$APPTYPE CONSOLE}

{$R *.res}

uses
  System.SysUtils;

begin
  try
    { TODO -oUser -cConsole Main : Insert code here }
    Write('Content-Type: text/plain');
    Writeln('');
    Writeln('');
    Write('hello world!');
  except
    on E: Exception do
      Writeln(E.ClassName, ': ', E.Message);
  end;
end.
