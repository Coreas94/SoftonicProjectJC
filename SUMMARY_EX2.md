# **SUMMARY_EX2.md**

## **Introduction**
This project aimed to implement a Laravel Artisan command to detect duplicate publisher URLs by comparing two CSV files: one containing `id_store` and `publisher_url`, and another serving as a catalog of known `publisher_url`s. The requirement suggested using an external script in a different language (such as Python, Ruby, or BASH), but due to time constraints and limited experience with these languages, the solution was fully implemented in Laravel using PHP. 

A placeholder command, `DetectDuplicatesPy.php`, was created to simulate how Laravel would execute a Python script. However, the actual implementation, `DetectDuplicatesPhp`, performs the comparison directly in PHP. The execution time for this approach is significantly high due to PHP's inherent limitations and the sequential processing of comparisons.

## **1. Why PHP Instead of an External Script?**
I chose to implement the comparison directly in Laravel using PHP because:
- I don't have enough experience in scripting with Python, Ruby, or BASH to confidently create a well-optimized solution in these languages.
- Given more time, I would have researched and implemented a more efficient script in Python, but I tried not to spend more than 3 hours implementing everything.
- I preferred to submit a solution that I fully understand and can debug, rather than presenting an external script that I might not fully grasp.
- I created the `DetectDuplicatesPy.php` command as a placeholder to simulate how Laravel would execute a Python script.

Currently, the execution of the `DetectDuplicatesPhp` command takes a very long time due to PHP’s limitations and the way it was implemented but in order to be able to test the functionality I added:

Limit options for each file:

- limit-source= to limit the number of records loaded from the source file.

- limit-catalog= to limit the number of records loaded from the catalog file.

**These limits help avoid performance issues when dealing with large datasets in PHP, ensuring the command doesn’t freeze or consume excessive memory.**


## **2. Potential Improvements**

- **Use `levenshtein()` Instead of `similar_text()`**: `levenshtein()` is generally faster and more optimized for calculating string similarity.
- **Implement Python for Better Performance**: If I had more experience with Python, I would have implemented the script using Python, as it is generally more efficient for this type of processing.

## **3. What Would I Have Done Differently with More Time?**
- Investigate how to make the script using python and its appropriate libraries for the exercise.
- In the current implementation with Laravel I would have tried to use levenshtein instead of similar_text for better script optimization.

## **4. How to Run the Code and Tests?**
- **Run the command:**

**Note: To check the operation, you must verify that the `catalog_publisher-url.csv` and `source_publiser-url.csv` files exist within `storage/app/dumps` since that is how everything will work and the output file is created in that same path.**

Command to apply limits:
```bash
  php artisan detect:duplicatesphp source_publisher-url.csv catalog_publisher-url.csv output.csv --limit-source=1000 --limit-catalog=1000
```

Command to run the script without limits:
  ```bash
  php artisan detect:duplicatesphp source_publisher-url.csv catalog_publisher-url.csv output.csv
  ```
- **Run the test:**
  ```bash
  php artisan test --filter=DetectDuplicatesPhpTest
  ```

