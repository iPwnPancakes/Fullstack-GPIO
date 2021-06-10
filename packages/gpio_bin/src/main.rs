extern crate sysfs_gpio;

use anyhow::{anyhow, Result};
use clap::{App, AppSettings, Arg, SubCommand};
use std::{process, thread::sleep, time};
use sysfs_gpio::{Direction, Pin};

struct PinConfig {
    value: u8,
    direction: Direction,
}

fn main() -> Result<()> {
    let app = App::new("GPIO_CLI")
        .setting(AppSettings::SubcommandRequired)
        .subcommands(vec![
            SubCommand::with_name("read").arg(Arg::with_name("pin_number").index(1).required(true)),
            SubCommand::with_name("write")
                .arg(Arg::with_name("pin_number").index(1).required(true))
                .arg(Arg::with_name("direction").index(2).required(true)),
        ])
        .get_matches();

    match app.subcommand() {
        ("read", Some(m)) => {
            let pin_number: u64 = m.value_of("pin_number").unwrap().parse().unwrap();

            match get_pin_status(pin_number) {
                Ok(x) => {
                    let value_as_string = x.value.to_string();
                    let direction_as_string = direction_to_string(x.direction).unwrap();
                    println!("{} {}", value_as_string, direction_as_string);
                    process::exit(0);
                }
                Err(_) => {
                    println!("Could not read from pin {}", pin_number);
                    process::exit(1);
                }
            }
        }
        ("write", Some(m)) => {
            let pin_number: u64 = m.value_of("pin_number").unwrap().parse().unwrap();
            let value = m.value_of("direction").unwrap();
            let direction = parse_direction(value).unwrap();

            match set_pin_direction(pin_number, direction) {
                Err(_) => {
                    println!("Could not read from pin {}", pin_number);
                    process::exit(1);
                }
                _ => {
                    process::exit(0);
                }
            }
        }
        (_, _) => {}
    }

    return Err(anyhow!("Help"));
}

fn parse_direction(str: &str) -> Result<Direction, anyhow::Error> {
    match str {
        "in" => Ok(Direction::In),
        "out" => Ok(Direction::Out),
        _ => Err(anyhow!(
            "Invalid Direction: Must be either in or out".to_string()
        )),
    }
}

fn get_pin_status(num: u64) -> Result<PinConfig, anyhow::Error> {
    let pin = Pin::new(num);

    let value = pin.get_value().unwrap();
    let direction = pin.get_direction().unwrap();

    let pin_config: PinConfig = PinConfig {
        value: value,
        direction: direction,
    };

    return Ok(pin_config);
}

fn set_pin_direction(pin_number: u64, direction: Direction) -> Result<(), anyhow::Error> {
    let pin = Pin::new(pin_number);

    return match pin.set_direction(direction) {
        Ok(()) => Ok(()),
        Err(_) => Err(anyhow!("Could not set direction of pin")),
    };
}

fn direction_to_string(direction: Direction) -> Result<String, anyhow::Error> {
    return match direction {
        Direction::In => Ok("in".to_owned()),
        Direction::Out => Ok("out".to_owned()),
        Direction::High => Ok("high".to_owned()),
        Direction::Low => Ok("low".to_owned()),
    };
}
