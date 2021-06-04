extern crate sysfs_gpio;

use std::{env, process, thread::sleep, time};
use sysfs_gpio::{Direction, Pin};

fn main() {
    let pin_num_arg = match env::args().nth(1) {
        Some(s) => s,
        None => {
            println!("Argument 1 must be specified");
            process::exit(1);
        }
    };
    let direction_arg = match env::args().nth(2) {
        Some(s) => s,
        None => {
            println!("Argument 2 must be specified");
            process::exit(1);
        }
    };

    let pin_num = match pin_num_arg.parse::<u64>() {
        Ok(n) => n,
        Err(_) => {
            println!("Argument 1 is not parseable to a number");
            process::exit(1);
        }
    };
    let direction = match parse_direction(direction_arg) {
        Ok(dir) => dir,
        Err(e) => {
            println!("Error: {}", e);
            process::exit(1);
        }
    };

    let my_pin = Pin::new(pin_num);

    let result = my_pin.with_exported(|| {
        sleep(time::Duration::from_millis(80));
        my_pin.set_direction(direction)?;
        return Ok(());
    });

    match result {
        Ok(_) => {
            println!("Done");
            process::exit(0);
        }
        Err(err) => {
            println!("Unhandled Error: {}", err);
            process::exit(1);
        }
    }
}

fn parse_direction(str: String) -> Result<Direction, String> {
    if str == "in" {
        return Ok(Direction::In);
    } else if str == "out" {
        return Ok(Direction::Out);
    } else {
        return Err("Invalid Direction: Must be either in or out".to_string());
    }
}
