using System;

public class Test{

    public int A(int a){
        Console.WriteLine("A running");
        return a * 100;
    }

    public string B(string a, int b){
        Console.WriteLine("B running");
        return a + (b*200).ToString();
    }

    public int B(int a, int b){
        return a + b;
    }

    public int B(int a){
        return a * 100;
    }

    public int B(){
        return 100;
    }

    public string B(string a){
        return "[" + a + "]";
    }


    public void xxx1(){
        Console.WriteLine("Save status");
    }

    public void xxx2(){
        Console.WriteLine("Restore status");
    }

    public object Invoke(string method, params object[] args){
        xxx1();
        Type[] t = new Type[args.Length];
        for(int i=args.Length; i-- > 0;){
            t[i] = args[i].GetType();
        }

        object ret = this.GetType().GetMethod(method, t).Invoke(this, args);
        xxx2();
        return ret;
    }

    public static void Main(string[] args){

        Test t = new Test();

        Console.WriteLine(t.Invoke("A", 1));
        Console.WriteLine(t.Invoke("B", "aaaa", 222));
        Console.WriteLine(t.Invoke("B"));
        Console.WriteLine(t.Invoke("B", 100));
        Console.WriteLine(t.Invoke("B", "aaaa"));
        Console.WriteLine(t.Invoke("B", 100, 200));
    }

}
/*
    <script type="text/javascript">

        function xxx1(){
            //console.log('备份当前状态');
        }

        function xxx2(){
            //console.log('恢复当前状态');
        }

        function aaa(){
            xxx1();
            arguments[0].apply(this, Array.prototype.slice.call(arguments, 1));
            xxx2();
        }

        aaa(function(a, b){
            alert(a + b);
        }, 1, 2);

        aaa(function(a, b, c, d){
            alert(a * b * c * d);
        }, 1, 2, 3, 4);

    </script>

*/

