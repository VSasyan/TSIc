package RedisToPostgres;
import java.text.*;
import java.sql.*;
import java.util.*;
import java.util.Date;
import org.json.JSONException;
import org.json.JSONObject;
import redis.clients.jedis.Jedis;

public class RedisToPostgres {
	@SuppressWarnings("deprecation")
	public static void main(String[] args) throws JSONException, ParseException {
		 //Connecting to Redis server on localhost
	      Jedis jedis = new Jedis("localhost");
	      System.out.println(" \n Connection to Redis server successfully \n");
	      // Tables variables
	      Date creation = new Date();
	      Date begin = new Date();
	      Date end = new Date();
	      String perturbation_name="";
	      String description="";
	      int perturbation_type=0;
	      int user_id=0;
	      int data_id=0;
	      int generatedkey=0;
	      String center="";
	      
	     // Get the stored data and print it
	      Set<String> keys = jedis.keys("*");
	      keys.remove("data:id");
	      Iterator<String> it=keys.iterator() ;   
	      while(it.hasNext()){  
	    	  
		         String key = it.next(); 
		         if (key != "data")
		         {
			         System.out.println("data found for key : " + key);
				     String data=jedis.get(key);
				     System.out.println("Stored data in redis:: \n "+ data);
				    
				     // parsing data 
				     JSONObject dataJson = new JSONObject(data);
				     System.out.println("\n Parsing data from key : " + key + "  .. \n");
				     data_id = dataJson.getInt("data_id");
				     System.out.println("data_id : "+ data_id);
				     user_id = dataJson.getInt("user_id");
				     System.out.println("user_id : "+ user_id);
				     perturbation_name = dataJson.getString("perturbation_name");
				     System.out.println("perturbation_name : "+perturbation_name);
				     String perturbation_creation_date = dataJson.getString("perturbation_creation_date");
				     System.out.println("perturbation_creation_date : "+perturbation_creation_date);
				     description = dataJson.getString("description");
				     System.out.println("description : "+description);
				     perturbation_type = dataJson.getInt("perturbation_type");
				     System.out.println("perturbation_type : "+perturbation_type);
				     center = dataJson.getString("center");
				     System.out.println("center : "+center);
				     String perturbation_begin_date = (String)dataJson.getString("begin_date");
				     System.out.println("perturbation_begin_date : "+perturbation_begin_date);
				     String perturbation_end_date = dataJson.getString("end_date");
				     System.out.println("perturbation_end_date : "+perturbation_end_date);
				     // parsing dates
				     SimpleDateFormat creation_sdf = new SimpleDateFormat("yyyy-MM-dd hh-mm-ss", java.util.Locale.FRANCE);
				     creation = creation_sdf.parse(perturbation_creation_date);
				     SimpleDateFormat begin_sdf = new SimpleDateFormat("yyyy-MM-dd hh-mm-ss", java.util.Locale.FRANCE);
				     begin = begin_sdf.parse(perturbation_begin_date);
				     SimpleDateFormat end_sdf = new SimpleDateFormat("yyyy-MM-dd hh-mm-ss", java.util.Locale.FRANCE);
				     end = end_sdf.parse(perturbation_end_date);
				     
				     System.out.println("\n parsing finiched \n");
	    	  }
	     
	     }
	     try {
	         Class.forName("org.postgresql.Driver");
	         String url = "jdbc:postgresql://localhost:5432/tsic";
	         String user = "postgres";
	         String passwd = "postgres";
	         Connection conn = DriverManager.getConnection(url, user, passwd);
	         System.out.println("\n Connexion to Postgres database successfully \n");
	         // Object Statement 
	         Statement state = conn.createStatement(ResultSet.TYPE_SCROLL_INSENSITIVE, ResultSet.CONCUR_UPDATABLE);
	         
	         //Insertion in perturbation table
	         System.out.println("*****data insertion in perturbation table*****");
	         PreparedStatement prepPerturbation = conn.prepareStatement(
	        		    "insert into perturbation (activated, valid, terminated, archived, creation_date) values (?,?,?,?,?)", Statement.RETURN_GENERATED_KEYS);
	         prepPerturbation.setBoolean(1, false);
	         prepPerturbation.setBoolean(2, false);
	         prepPerturbation.setBoolean(3, false);
	         prepPerturbation.setBoolean(4, false);
	         prepPerturbation.setDate(5, new java.sql.Date(creation.getTime()));
	         prepPerturbation.execute();
	         System.out.println("*****done successfully*****");
	         
	         // retrieving perturbation_id
	         ResultSet rs = prepPerturbation.getGeneratedKeys();
	         rs.next();
	         generatedkey = rs.getInt(1);
	         
	         // Insertion in formulation table
	         System.out.println("*****data insertion in formulation table*****");
	         PreparedStatement prepFormulation = conn.prepareStatement(
	        		    "insert into formulation (particulier_id, perturbation_id, type_id, name, description, center, geojson, creation_date, begin_date, end_date, valid_formulation) values (?,?,?,?,?,?,?,?,?,?,?)");
	         prepFormulation.setInt(1, user_id);
	         prepFormulation.setInt(2, generatedkey);
	         prepFormulation.setInt(3, perturbation_type);
	         prepFormulation.setString(4, perturbation_name);
	         prepFormulation.setString(5, description);
	         prepFormulation.setObject(6, center, java.sql.Types.OTHER);
	         prepFormulation.setString(7, "geojson");
	         prepFormulation.setDate(8, new java.sql.Date(creation.getTime()));
	         prepFormulation.setDate(9, new java.sql.Date(begin.getTime()));
	         prepFormulation.setDate(10, new java.sql.Date(end.getTime()));
	         prepFormulation.setBoolean(11, false);
	         prepFormulation.execute();
	         System.out.println("*****done successfully*****");

	       } catch (Exception e) {
	         e.printStackTrace();

	       }      
	 }

	}

